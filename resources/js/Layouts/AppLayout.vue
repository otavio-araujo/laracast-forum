<script setup>
import {ref} from 'vue';
import {Head, Link, router, usePage} from '@inertiajs/vue3';
import ApplicationMark from '@/Components/ApplicationMark.vue';
import Banner from '@/Components/Banner.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import ConfirmationModalWrapper from "@/Components/ConfirmationModalWrapper.vue";

defineProps({
    title: String,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(route('current-team.update'), {
        team_id: team.id,
    }, {
        preserveState: false,
    });
};

const logout = () => {
    router.post(route('logout'));
};

const menu = [
    {
        name: 'Dashboard',
        url: route('dashboard'),
        route: 'dashboard',
        when: () => usePage().props.auth.user,
    },
    {
        name: 'Posts',
        url: route('posts.index'),
        route: 'posts.index',
    },
    {
        name: 'Create a Post',
        url: route('posts.create'),
        route: 'posts.create',
        when: () => usePage().props.permissions.create_posts,
    },
];
</script>

<template>
    <div>
        <Head :title="title"/>

        <Banner/>

        <div class="min-h-screen bg-gray-100">
            <nav class="border-b border-gray-100 bg-white">
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationMark class="block h-9 w-auto"/>
                                </Link>
                            </div>

                            <!-- Navigation Links -->
                            <div class="hidden space-x-8 sm:ms-10 sm:-my-px sm:flex">
                                <template v-for="item in menu" :key="item.name">
                                    <NavLink
                                        v-if="item.when ? item.when() : true"
                                        :active="route().current(item.route)"
                                        :href="item.url">
                                        {{ item.name }}
                                    </NavLink>
                                </template>
                            </div>
                        </div>

                        <div class="hidden sm:ms-6 sm:flex sm:items-center">

                            <!-- Settings Dropdown -->
                            <div v-if="$page.props.auth.user" class="relative ms-3">
                                <Dropdown align="right" width="48">
                                    <template #trigger>
                                        <button v-if="$page.props.jetstream.managesProfilePhotos"
                                                class="flex rounded-full border-2 border-transparent text-sm transition focus:border-gray-300 focus:outline-none">
                                            <img :alt="$page.props.auth.user.name"
                                                 :src="$page.props.auth.user.profile_photo_url"
                                                 class="h-8 w-8 rounded-full object-cover">
                                        </button>

                                        <span v-else class="inline-flex rounded-md">
                                            <button
                                                class="inline-flex items-center rounded-md border border-transparent bg-white px-3 py-2 text-sm font-medium leading-4 text-gray-500 transition duration-150 ease-in-out hover:text-gray-700 focus:bg-gray-50 focus:outline-none active:bg-gray-50"
                                                type="button">
                                                {{ $page.props.auth.user.name }}

                                                <svg class="h-4 w-4 ms-2 -me-0.5" fill="none"
                                                     stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M19.5 8.25l-7.5 7.5-7.5-7.5" stroke-linecap="round"
                                                          stroke-linejoin="round"/>
                                                </svg>
                                            </button>
                                        </span>
                                    </template>

                                    <template #content>
                                        <!-- Account Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            Manage Account
                                        </div>

                                        <DropdownLink :href="route('profile.show')">
                                            Profile
                                        </DropdownLink>

                                        <DropdownLink v-if="$page.props.jetstream.hasApiFeatures"
                                                      :href="route('api-tokens.index')">
                                            API Tokens
                                        </DropdownLink>

                                        <div class="border-t border-gray-200"/>

                                        <!-- Authentication -->
                                        <form @submit.prevent="logout">
                                            <DropdownLink as="button">
                                                Log Out
                                            </DropdownLink>
                                        </form>
                                    </template>
                                </Dropdown>
                            </div>
                            <div v-else>
                                <Link :href="route('login')">
                                    Login
                                </Link>
                            </div>
                        </div>

                        <!-- Hamburger -->
                        <div class="flex items-center -me-2 sm:hidden">
                            <button
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                                @click="showingNavigationDropdown = ! showingNavigationDropdown">
                                <svg
                                    class="h-6 w-6"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }"
                                        d="M4 6h16M4 12h16M4 18h16"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                    />
                                    <path
                                        :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }"
                                        d="M6 18L18 6M6 6l12 12"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}"
                     class="sm:hidden">
                    <div class="pt-2 pb-3 space-y-1">
                        <ResponsiveNavLink :active="route().current('dashboard')" :href="route('dashboard')">
                            Dashboard
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div v-if="$page.props.auth.user" class="border-t border-gray-200 pt-4 pb-1">
                        <div class="flex items-center px-4">
                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="shrink-0 me-3">
                                <img :alt="$page.props.auth.user.name"
                                     :src="$page.props.auth.user.profile_photo_url"
                                     class="h-10 w-10 rounded-full object-cover">
                            </div>

                            <div>
                                <div class="text-base font-medium text-gray-800">
                                    {{ $page.props.auth.user.name }}
                                </div>
                                <div class="text-sm font-medium text-gray-500">
                                    {{ $page.props.auth.user.email }}
                                </div>
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink :active="route().current('profile.show')" :href="route('profile.show')">
                                Profile
                            </ResponsiveNavLink>

                            <ResponsiveNavLink v-if="$page.props.jetstream.hasApiFeatures"
                                               :active="route().current('api-tokens.index')"
                                               :href="route('api-tokens.index')">
                                API Tokens
                            </ResponsiveNavLink>

                            <!-- Authentication -->
                            <form method="POST" @submit.prevent="logout">
                                <ResponsiveNavLink as="button">
                                    Log Out
                                </ResponsiveNavLink>
                            </form>

                            <!-- Team Management -->
                            <template v-if="$page.props.jetstream.hasTeamFeatures">
                                <div class="border-t border-gray-200"/>

                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    Manage Team
                                </div>

                                <!-- Team Settings -->
                                <ResponsiveNavLink :active="route().current('teams.show')"
                                                   :href="route('teams.show', $page.props.auth.user.current_team)">
                                    Team Settings
                                </ResponsiveNavLink>

                                <ResponsiveNavLink v-if="$page.props.jetstream.canCreateTeams"
                                                   :active="route().current('teams.create')"
                                                   :href="route('teams.create')">
                                    Create New Team
                                </ResponsiveNavLink>

                                <!-- Team Switcher -->
                                <template v-if="$page.props.auth.user.all_teams.length > 1">
                                    <div class="border-t border-gray-200"/>

                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Switch Teams
                                    </div>

                                    <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                        <form @submit.prevent="switchToTeam(team)">
                                            <ResponsiveNavLink as="button">
                                                <div class="flex items-center">
                                                    <svg v-if="team.id == $page.props.auth.user.current_team_id"
                                                         class="h-5 w-5 text-green-400 me-2"
                                                         fill="none" stroke="currentColor"
                                                         stroke-width="1.5" viewBox="0 0 24 24"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"/>
                                                    </svg>
                                                    <div>{{ team.name }}</div>
                                                </div>
                                            </ResponsiveNavLink>
                                        </form>
                                    </template>
                                </template>
                            </template>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header v-if="$slots.header" class="bg-white shadow">
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">
                    <slot name="header"/>
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot/>
            </main>
        </div>

        <ConfirmationModalWrapper/>

    </div>
</template>
