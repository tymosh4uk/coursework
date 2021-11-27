import vueRouter from 'vue-router';
import Vue from 'vue';

Vue.use(vueRouter);

import Index from "./views/Index";
import Blog from "./views/Blog";
import Receipt from "./views/Receipt";
import CreateKitchen from "./views/CreateKitchen";
import CreateReceipt from "./views/CreateReceipt";
import App from "./views/App";
import AllReceipt from "./views/AllReceipt";
import Admin from "./views/AdminStatistics";
import AdminHeader from "./components/Test";
import UserHeader from "./components/Header";
import paginate from 'vuejs-paginate'
Vue.component('Paginate', paginate)


const router = new vueRouter({
    mode: "history",
    routes: [
        {
            path: '/',
            components: {
                default: Index,
                header: UserHeader
            }
        },
        {
            path: '/blog',
            component: Blog
        },
        {
            path: '/receipt/:id',
            components: {
                default: Receipt,
                header: UserHeader
            }
        },
        {
            path: '/create',
            components:{
                default: CreateKitchen,
                header: AdminHeader
            }
        },
        {
            path: '/createReceipt',
            components: {
                default: CreateReceipt,
                header: UserHeader
            },
            meta: {auth: true}
        },
        {
            path: '/app',
            component: App
        },
        {
            path: '/recepty',
            components: {
                default: AllReceipt,
                header: UserHeader
            }
        },
        {
            path: '/admin',
            components: {
                default: Admin,
                header: AdminHeader
            }
        }


    ]
})

router.beforeEach(async (to, from, next) => {
    var currentUser;

    const requireAuth = to.matched.some(record => record.meta.auth)
    await axios.get('/currentId')
        .then(res => {
        //console.log(res.data);
            currentUser = res.data;


        }).catch((error) => {
            this.showErrors(error.response.data.error)
        });

    //console.log(requireAuth);
    //console.log(currentUser);

    if (requireAuth && !currentUser) {

        next(window.location.href = '/login')


    } else {
        next()
    }
})


export default router
