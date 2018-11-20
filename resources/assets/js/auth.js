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
        return window.localStorage.getItem('user');
    },

    getId() {
        const token = window.localStorage.getItem('token');
        if (token) {
            return jwt_decode(window.localStorage.getItem('token')).sub;
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
    },

    updateUser(user) {
        window.localStorage.setItem('user', user);
        EventBus.$emit('user-updated', user);
    },

    async isMember(studioId) {
        if (!this.isLoggedIn()) {
            return false;
        }
        const id = this.getId();
        let response = await axios.get(`/api/devstudios/user-studios/${id}`);
        let filteredStudios = response.data.studios.filter(studio => studio.id === studioId);
        return filteredStudios.length === 1;
    }
};

export default Auth;