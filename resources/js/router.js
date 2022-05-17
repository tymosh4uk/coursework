import vueRouter from 'vue-router';
import Vue from 'vue';

Vue.use(vueRouter);

import Index from "./views/Index";
import Blog from "./views/Blog";
import Receipt from "./views/Receipt";
import CreateKitchen from "./views/CreateKitchen";
import CreateReceipt from "./views/CreateReceipt";
import AllReceipt from "./views/AllReceipt";
import Admin from "./views/AdminStatistics";
import AdminHeader from "./components/AdminHeader";
import UserHeader from "./components/Header";
import MyHeader from "./components/MyHeader";
import Saved from "./views/Saved";
import paginate from 'vuejs-paginate'
import AdminAllReceipt from "./views/AdminAllReceipt";
import AdminCreate from "./views/AdminCreate";
import AdminEdit from "./views/AdminEdit";
import AdminUser from "./views/AdminUsers";
import FindReceipt from "./views/FindReceipt";
Vue.component('Paginate', paginate)


const router = new vueRouter({
    mode: "history",
    routes: [
        {
            path: '/',
            components: {
                default: Index,
                header: MyHeader
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
            path: '/recepty',
            components: {
                default: AllReceipt,
                header: MyHeader
            }
        },
        {
            path: '/admin',
            components: {
                default: Admin,
                header: AdminHeader
            }
        },
        {
            path: '/adminRecepty',
            components: {
                default: AdminAllReceipt,
                header: AdminHeader
            }
        },
        {
            path: '/adminCreate',
            components: {
                default: AdminCreate,
                header: AdminHeader
            }
        },
        {
            path: '/adminUsers',
            components: {
                default: AdminUser,
                header: AdminHeader
            }
        },
        {
            path: '/adminEdit/:id',
            components: {
                default: AdminEdit,
                header: AdminHeader
            }
        },
        {
            path: '/saved',
            components: {
                default: Saved,
                header: UserHeader
            }
        },
        {
            path: '/find',
            components: {
                default: FindReceipt,
                header: UserHeader
            }
        }


    ]
})

router.beforeEach(async (to, from, next) => {
    var currentUser;
    const requireAuth = to.matched.some(record => record.meta.auth)
    await axios.get('/currentId')
        .then(res => {
            currentUser = res.data;
        }).catch((error) => {
            this.showErrors(error.response.data.error)
        });

    if (requireAuth && !currentUser) {
        next(window.location.href = '/login')

    } else {
        next()
    }
})


export default router
