import { default as PageLogin } from "@/views/pages/auth/login/Main";
import { default as PageRegister } from "@/views/pages/auth/register/Main";
import { default as PageResetPassword } from "@/views/pages/auth/reset-password/Main";
import { default as PageForgotPassword } from "@/views/pages/auth/forgot-password/Main";
import { default as PageNotFound } from "@/views/pages/shared/404/Main";

import { default as PageDashboard } from "@/views/pages/private/dashboard/Main";
import { default as PageProfile } from "@/views/pages/private/profile/Main";
import { default as PageSetting } from "@/views/pages/private/settings/Index";

import { default as PageUsers } from "@/views/pages/private/users/Index";
import { default as PageUsersCreate } from "@/views/pages/private/users/Create";
import { default as PageUsersEdit } from "@/views/pages/private/users/Edit";

import { default as PageRole } from "@/views/pages/private/roles/Index";
import { default as PageRoleCreate } from "@/views/pages/private/roles/Create";
import { default as PageRoleEdit } from "@/views/pages/private/roles/Edit";

import { default as PageAbility } from "@/views/pages/private/abilities/Index";
import { default as PageAbilityCreate } from "@/views/pages/private/abilities/Create";
import { default as PageAbilityEdit } from "@/views/pages/private/abilities/Edit";

import { default as PageMenu } from "@/views/pages/private/website/menus/Index";
import { default as PageMenuCreate } from "@/views/pages/private/website/menus/Create";
import { default as PageMenuEdit } from "@/views/pages/private/website/menus/Edit";
import { default as EditItem } from "@/views/pages/private/website/menus/EditItem";

import { default as PageTemplate } from "@/views/pages/private/website/templates/Index";
import { default as PageTemplateCreate } from "@/views/pages/private/website/templates/Create";
import { default as PageTemplateEdit } from "@/views/pages/private/website/templates/Edit";

import { default as PagePage } from "@/views/pages/private/website/pages/Index";
import { default as PagePageCreate } from "@/views/pages/private/website/pages/Create";
import { default as PagePageEdit } from "@/views/pages/private/website/pages/Edit";
import { default as PageShowSection } from "@/views/pages/private/website/pages/ShowSection";
import { default as PageStoreComponents } from "@/views/pages/private/website/pages/StoreComponents";

import { default as PageComponent } from "@/views/pages/private/website/components/Index";
import { default as PageComponentEdit } from "@/views/pages/private/website/components/Edit";
import { default as PageComponentType } from "@/views/pages/private/website/components/TypeIndex";
import { default as PageComponentTypeCreate } from "@/views/pages/private/website/components/CreateType";
import { default as PageComponentTypeEdit } from "@/views/pages/private/website/components/EditType";

/* Web Site pages */
import { default as PageIndexSite } from "@/views/pages/public/home/Index";
import { default as PagesSite } from "@/views/pages/public/home/PagesSite";
import { default as PageNotFoundSite } from "@/views/pages/public/template/components/not-found/404";

import abilities from "@/stub/abilities";

const routes = [
    {
        name: "home",
        path: "/",
        meta: { requiresAuth: false },
        component: PageIndexSite,
    },
    {
        name: "webpages",
        path: "/page/:id",
        meta: { requiresAuth: false },
        component: PagesSite,
    },
    {
        name: "panel",
        path: "/panel",
        children: [
            {
                name: "dashboard",
                path: "dashboard",
                meta: { requiresAuth: true },
                component: PageDashboard,
            },
            {
                name: "profile",
                path: "profile",
                meta: { requiresAuth: true, isOwner: true },
                component: PageProfile,
            },
            {
                path: "users",
                children: [
                    {
                        name: "users.list",
                        path: "list",
                        meta: { requiresAuth: true, requiresAbility: abilities.LIST_USER },
                        component: PageUsers,
                    },
                    {
                        name: "users.create",
                        path: "create",
                        meta: { requiresAuth: true, requiresAbility: abilities.CREATE_USER },
                        component: PageUsersCreate,
                    },
                    {
                        name: "users.edit",
                        path: ":id/edit",
                        meta: { requiresAuth: true, requiresAbility: abilities.EDIT_USER },
                        component: PageUsersEdit,
                    },
                ]
            },
            {
                name: "edit.setting",
                path: "settings/:id/edit",
                meta: { requiresAuth: true, requiresAbility: abilities.EDIT_SETTING },
                component: PageSetting,
            },
            {
                path: "roles",
                children: [
                    {
                        name: "roles.list",
                        path: "list",
                        meta: { requiresAuth: true, requiresAbility: abilities.LIST_ROLE },
                        component: PageRole,
                    },
                    {
                        name: "roles.create",
                        path: "create",
                        meta: { requiresAuth: true, requiresAbility: abilities.LIST_ROLE },
                        component: PageRoleCreate,
                    },
                    {
                        name: "roles.edit",
                        path: ":id/edit",
                        meta: { requiresAuth: true, requiresAbility: abilities.LIST_ROLE },
                        component: PageRoleEdit,
                    },
                    {
                        name: "roles.allbilities",
                        path: "allbilities",
                        meta: { requiresAuth: true, requiresAbility: abilities.LIST_ABILITY },
                        component: PageAbility,
                    },
                    {
                        name: "roles.create.ability",
                        path: "add/ability",
                        meta: { requiresAuth: true, requiresAbility: abilities.LIST_ABILITY },
                        component: PageAbilityCreate,
                    },
                    {
                        name: "roles.ability.edit",
                        path: ":id/editability",
                        meta: { requiresAuth: true, requiresAbility: abilities.LIST_ABILITY },
                        component: PageAbilityEdit,
                    },
                ]
            },
            {
                path: "pages",
                children: [
                    {
                        name: "menus.list",
                        path: "menus",
                        meta: { requiresAuth: false },
                        component: PageMenu,
                    },
                    {
                        name: "menus.create",
                        path: "menus/create",
                        meta: { requiresAuth: true },
                        component: PageMenuCreate,
                    },
                    {
                        name: "menus.edit",
                        path: "menus/:id",
                        meta: { requiresAuth: true },
                        component: PageMenuEdit,
                    },
                    {
                        name: "menus.showitem",
                        path: "menus/:menu/showitem/:id",
                        meta: { requiresAuth: true },
                        component: EditItem,
                    },
                    {
                        name: "templates.list",
                        path: "templates",
                        meta: { requiresAuth: true },
                        component: PageTemplate,
                    },
                    {
                        name: "templates.create",
                        path: "templates/create",
                        meta: { requiresAuth: true },
                        component: PageTemplateCreate,
                    },
                    {
                        name: "templates.edit",
                        path: "templates/:id",
                        meta: { requiresAuth: true },
                        component: PageTemplateEdit,
                    },
                    {
                        name: "pages.list",
                        path: "page",
                        meta: { requiresAuth: true },
                        component: PagePage,
                    },
                    {
                        name: "pages.create",
                        path: "page/create",
                        meta: { requiresAuth: true },
                        component: PagePageCreate,
                    },
                    {
                        name: "pages.edit",
                        path: "page/:id",
                        meta: { requiresAuth: true },
                        component: PagePageEdit,
                    },
                    {
                        name: "pages.show.section",
                        path: "page/:page/section/:id",
                        meta: { requiresAuth: true },
                        component: PageShowSection,
                    },
                    {
                        name: "pages.store.column.component",
                        path: "page/:page/section/:section/column/:id",
                        meta: { requiresAuth: true },
                        component: PageStoreComponents,
                    },
                    {
                        name: "components.list",
                        path: "components",
                        meta: { requiresAuth: true },
                        component: PageComponent,
                    },
                    {
                        name: "components.edit",
                        path: "components/:id",
                        meta: { requiresAuth: true },
                        component: PageComponentEdit,
                    },
                    {
                        name: "componenttype.list",
                        path: "componenttype",
                        meta: { requiresAuth: true },
                        component: PageComponentType,
                    },
                    {
                        name: "componenttype.create",
                        path: "componenttype/create",
                        meta: { requiresAuth: true },
                        component: PageComponentTypeCreate,
                    },
                    {
                        name: "componenttype.edit",
                        path: "componenttype/:id",
                        meta: { requiresAuth: true },
                        component: PageComponentTypeEdit,
                    },
                ]
            }
        ]
    },
    {
        path: "/login",
        name: "login",
        meta: { requiresAuth: false, isPublicAuthPage: true },
        component: PageLogin,
    },
    {
        path: "/register",
        name: "register",
        meta: { requiresAuth: false, isPublicAuthPage: true },
        component: PageRegister,
    },
    {
        path: "/reset-password",
        name: "resetPassword",
        meta: { requiresAuth: false, isPublicAuthPage: true },
        component: PageResetPassword,
    },
    {
        path: "/forgot-password",
        name: "forgotPassword",
        meta: { requiresAuth: false, isPublicAuthPage: true },
        component: PageForgotPassword,
    },
    {
        path: "/:catchAll(.*)",
        name: "notFound",
        meta: { requiresAuth: false },
        component: PageNotFound,
    },
    {
        path: '/:pathMatch(.*)*',
        name: "notFound",
        meta: { requiresAuth: false },
        beforeEnter: (to, from, next) => {
            if (to.path.startsWith("/panel")) {
                to.matched[0].components = { default: PageNotFound };
            } else {
                to.matched[0].components = { default: PageNotFoundSite };
            }
            next();
        }
    }
]

export default routes;
