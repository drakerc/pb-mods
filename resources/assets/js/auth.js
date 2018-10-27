import axios from 'axios';
import { EventBus } from "./event-bus";

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

    logout() {
        window.localStorage.removeItem('token');
        window.localStorage.removeItem('user');

        EventBus.$emit('logged-out');
    }
};