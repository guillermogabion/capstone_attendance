import Vue from 'vue';
import VueRouter from 'vue-router';
import { Self } from "../repositories/user.api";
import store from '../store'
import pages from './pages'


Vue.use(VueRouter)

const routes = [
    ...pages
]

const router = new VueRouter({
    mode : 'history',
    routes,
    linkActiveClass: "active",
    linkExactActiveClass: "exact-active",
});

function guardRoutes(to, next) {
    const guest_routes = [
        'login', 'landing'
    ]
    if ((guest_routes.includes(to.name)) && localStorage.getItem('token') === '') {
        next()
    } else if (localStorage.getItem('token') === '') {
        next({ name: 'landing' })
    } else if (guest_routes.includes(to.name)) {
        next({ name: 'dashboard' })
    } else {
        next()
    }
}

router.beforeEach((to, from, next) => {
    if (localStorage.getItem('token')) {
        Self().then(({ data }) => {
            store.commit('login', data)
            localStorage.setItem('token', data.access_token)
            guardRoutes(to, next)
        }).catch(err => {
            localStorage.removeItem('token')
            console.log(err)
        })
    } else {
        guardRoutes(to, next)
    }
})

export default router;