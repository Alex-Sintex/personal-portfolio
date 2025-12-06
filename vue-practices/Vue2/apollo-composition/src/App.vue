<template>
  <h3>Notifications</h3>
  <ul>
    <li v-for="(comment, index) in comments" :key="index">
      <b>{{ comment.name }}</b> {{ comment.text }}
    </li>
  </ul>
</template>

<script lang="ts" setup>
import { watch, ref } from 'vue';
import { useSubscription } from '@vue/apollo-composable';
import { gql } from 'graphql-tag';

const comments = ref<{ name: string; text: string }[]>([])
const { result } = useSubscription(gql`
      subscription {
      commentCreated {
        name
        text
      }
    }
      `,
  () => ({

  }))

watch(result, data => {
  if (data?.commentCreated) {
    comments.value.push(data.commentCreated)
  }
}
)
</script>