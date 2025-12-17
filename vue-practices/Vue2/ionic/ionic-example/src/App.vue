<template>
  <ion-page>
    <ion-header>
      <ion-toolbar>
        <ion-title>Capacitor Plugins</ion-title>
      </ion-toolbar>
    </ion-header>
    <ion-content class="ion-padding">
      <img :src="imageURL" alt="User img">
      <button @click="takePicture">Take Picture</button>
    </ion-content>
  </ion-page>
</template>

<script setup>
import { Camera, CameraResultType } from '@capacitor/camera';
import { ref } from 'vue';

const imageURL = ref('');

const takePicture = async () => {
  const image = await Camera.getPhoto({
    quality: 80,
    allowEditing: true,
    resultType: CameraResultType.Uri
  })

  imageURL.value = image.webPath
}
</script>

<style scoped>
  img {
    width: 100%;
    height: 100%;
    margin-bottom: 16px;
    border-radius: 8px;
    position: fixed;
  }
</style>