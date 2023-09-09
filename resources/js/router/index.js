import { createRouter, createWebHistory } from 'vue-router'
import PocetnaView from '../views/PocetnaView.vue'
import RegistracijaView from '../views/RegistracijaView.vue'
import PrijavaView from '../views/PrijavaView.vue'
import GrupaView from '../views/GrupaView.vue'
import KorisniciView from '../views/KorisniciView.vue'






const router = createRouter({
    history: createWebHistory(import.meta.env.BASE_URL),
    routes: [
        {
            path: '/',
            name: 'pocetna',
            component: PocetnaView
        },
        {
            path: '/registracija',
            name: 'registracija',
            component: RegistracijaView
        },
        {
            path: '/prijava',
            name: 'prijava',
            component: PrijavaView
        },
        {
            path: '/grupe',
            name: 'grupe',
            component: GrupaView
        },
        {
            path: '/korisnici',
            name: 'korisnici',
            component: KorisniciView
        },








    ]
})

export default router
