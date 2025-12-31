<template>
    <div>
        <nav class="nav">
            <ul class="nav__list">
                <li class="nav__item">
                    <NuxtLink to="/" class="nav__link">Home</NuxtLink>
                </li>
                <li class="nav__item">
                    <NuxtLink to="/about" class="nav__link">About</NuxtLink>
                </li>
                <li class="nav__item">
                    <NuxtLink to="/services" class="nav__link">Services</NuxtLink>
                </li>
                <li class="nav__item">
                    <NuxtLink to="/contact" class="nav__link">Contact</NuxtLink>
                </li>
            </ul>
        </nav>
        <slot />
    </div>
</template>