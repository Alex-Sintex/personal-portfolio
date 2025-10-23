<script setup>
import { Head } from '@inertiajs/vue3';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
});
</script>

<template>

    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <header class="grid grid-cols-2 items-center gap-2 py-8 lg:grid-cols-3">
            <nav v-if="canLogin"
                class="bg-white dark:bg-gray-900 fixed w-full z-20 top-0 start-0 border-b border-gray-200 dark:border-gray-600">
                <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
                    <a v-if="$page.props.auth.user" :href="route('dashboard')"
                        class="flex items-center space-x-3 rtl:space-x-reverse">
                    </a>
                    <template v-else>
                        <div class="flex md:order-2 space-x-3 md:space-x-0 rtl:space-x-reverse">
                            <a :href="route('login')"
                                class="mr-4 text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Log in
                            </a>
                            <a v-if="canRegister" :href="route('register')"
                                class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-4 py-2 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
                                Register
                            </a>
                        </div>
                    </template>
                    <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1"
                        id="navbar-sticky">
                        <img src="/images/background.jpg"
                            class="flex flex-col mr-4 p-4 md:p-0 h-8 items-center justify-between mx-auto border border-gray-100 rounded-lg"
                            alt="Logo">
                        <ul
                            class="flex flex-col p-4 md:p-0 mt-4 font-medium border border-gray-100 rounded-lg bg-gray-50 md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0 md:bg-white dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                            <li>
                                <a href="#home"
                                    class="block py-2 px-3 text-white bg-blue-700 rounded-sm md:bg-transparent md:text-blue-700 md:p-0 md:dark:text-blue-500"
                                    aria-current="page">
                                    Home
                                </a>
                            </li>
                            <li>
                                <a href="#about"
                                    class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">About</a>
                            </li>
                            <li>
                                <a href="#services"
                                    class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Services</a>
                            </li>
                            <li>
                                <a href="#contact"
                                    class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:hover:text-blue-700 md:p-0 md:dark:hover:text-blue-500 dark:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Contact</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
        </header>
        <main class="scroll-smooth">
            <section id="home" class="min-h-screen p-8 bg-gray-100 dark:bg-gray-800">
                <h2 class="text-2xl font-bold text-center mb-4">🏠 Home Section</h2>
                <p class="text-center">Welcome to the home section.</p>
            </section>

            <section id="about" class="min-h-screen p-8 bg-white dark:bg-gray-900">
                <h2 class="text-2xl font-bold text-center mb-4">ℹ️ About Section</h2>
                <p class="text-center">Learn more about us here.</p>
            </section>

            <section id="services" class="min-h-screen p-8 bg-gray-100 dark:bg-gray-800">
                <h2 class="text-2xl font-bold text-center mb-4">🛠️ Services Section</h2>
                <p class="text-center">These are the services we offer.</p>
            </section>

            <section id="contact" class="min-h-screen p-8 bg-white dark:bg-gray-900">
                <h2 class="text-2xl font-bold text-center mb-4">📞 Contact Section</h2>
                <p class="text-center">Get in touch with us here.</p>
            </section>
        </main>
    </div>
</template>
