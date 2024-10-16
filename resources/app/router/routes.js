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



import abilities from "@/stub/abilities";

const routes = [
    {
        name: "home",
        path: "/",
        meta: { requiresAuth: false, isPublicAuthPage: true },
        component: PageLogin,
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
]

export default routes;
