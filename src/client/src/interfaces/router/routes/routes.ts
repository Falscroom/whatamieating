import {DefaultView} from '@interfaces/views';
import {whatIamEatingRoutes} from '@interfaces/router/routes/whatIamEating';
import {loginRoutes} from '@interfaces/router/routes/login';
import {PageLayout} from '@interfaces/layout';

export const routes = [
    {
        path: '/',
        redirect: '/login',
        component: DefaultView,
        children: [
            ...loginRoutes,
        ]
    },
    {
        path: '/',
        component: PageLayout,
        children: [
            ...whatIamEatingRoutes,
        ]
    }
]
