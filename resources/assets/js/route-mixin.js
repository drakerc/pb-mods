import axios from 'axios';

function getData(to) {
    return new Promise((resolve) => {
        let serverData = JSON.parse(window.window.mods_model) || {};
        if (!serverData.path || to.path !== serverData.path) {
            axios.get(`/api${to.path}`).then(({ data }) => {
                resolve(data);
            });
        } else {
            resolve(serverData);
        }
    });
};

export default {
    beforeRouteEnter: (to, from, next) => {
        getData(to).then((data) => {
            next(component => component.assignData(data));
        });
    },
};