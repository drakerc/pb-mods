import axios from 'axios';
import { EventBus } from "./event-bus";
import jwt_decode from 'jwt-decode';

export const Auth = {

    login(token, user) {
        window.localStorage.setItem('token', token);
        window.localStorage.setItem('user', user);

        axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
        EventBus.$emit('logged-in', user);
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

    logout() {
        window.localStorage.removeItem('token');
        window.localStorage.removeItem('user');
        EventBus.$emit('logged-out');
    }
};