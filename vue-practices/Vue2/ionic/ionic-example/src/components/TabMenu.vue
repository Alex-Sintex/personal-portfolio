<template>
    <ion-page>
        <ion-tabs>
            <ion-router-outlet></ion-router-outlet>
            <ion-tab-bar slot="bottom">
                <ion-tab-button tab="home" href="/home">
                    <ion-icon :icon="playCircle" />
                    <ion-label>Home</ion-label>
                </ion-tab-button>
                <ion-tab-button tab="library" href="/library">
                    <ion-icon :icon="radio" />
                    <ion-label>Library</ion-label>
                </ion-tab-button>
                <ion-tab-button tab="search" href="/search">
                    <ion-icon :icon="search" />
                    <ion-label>Search</ion-label>
                </ion-tab-button>
                <ion-tab-button tab="radio" href="/radio">
                    <ion-icon :icon="radio" />
                    <ion-label>Radio</ion-label>
                </ion-tab-button>
            </ion-tab-bar>
        </ion-tabs>
    </ion-page>
</template>

<script setup>
import { IonPage, IonTabs, IonRouterOutlet, IonTabBar, IonTabButton, IonIcon, IonLabel } from '@ionic/vue';
import { playCircle, radio, search } from 'ionicons/icons';
</script>