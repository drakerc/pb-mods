import axios from 'axios';
import { EventBus } from "./event-bus";
import jwt_decode from 'jwt-decode';

export const Auth = {

    login(token, user, gravatar) {
        window.localStorage.setItem('token', token);
        window.localStorage.setItem('user', user);
        window.localStorage.setItem('gravatar', gravatar);

        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        EventBus.$emit('logged-in', user, gravatar);
    },

    isLoggedIn() {
        return !! window.localStorage.getItem('token');
    },

    getUser() {
        const token = window.localStorage.getItem('token');
        if (token) {
            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
            return window.localStorage.getItem('user');
        }
    },

    getId() {
        const token = window.localStorage.getItem('token');
        if (token) {
            return jwt_decode(window.localStorage.getItem('token')).sub;
        }
        return null;
    },

    getUserData() {
        const userData = window.localStorage.getItem('user-data');
        if (userData) {
            return userData;
        }
        const token = window.localStorage.getItem('token');
        if (token) {
            axios.get('/api/auth/user').then((response) => {
                window.localStorage.setItem('user-data', JSON.stringify(response.data));
                console.log(response.data);
                return response.data;
            });
        }
        return null;
    },

    getUserGravatar() {
        let gravatar = window.localStorage.getItem('gravatar');
        if (gravatar) {
            return gravatar;
        }
        console.log('dupa');
        let userData = window.localStorage.getItem('user-data');
        if (userData) {
            gravatar = JSON.parse(userData).gravatar;
            window.localStorage.setItem('gravatar', gravatar);
            return gravatar;
        }
        const token = window.localStorage.getItem('token');
        if (token) {
            axios.get('/api/auth/user').then((response) => {
                gravatar = response.data['gravatar'];
                window.localStorage.setItem('gravatar', gravatar);
                EventBus.$emit('gravatar-received', gravatar);
            });
        }
        return null;
    },

    logout() {
        return axios.get('/api/auth/logout', {
            headers: {
                'Authorization': 'Bearer ' + window.localStorage.getItem('token')
            }
        }).then((response) => {
            window.localStorage.clear();
            EventBus.$emit('logged-out');
        }).catch(err => {
            console.error(err);
            if (err.response.status === 401) {
                // assumming that token is invalid
                window.localStorage.clear();
            }
        });
    }
};

export default Auth;