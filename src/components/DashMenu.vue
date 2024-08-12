<template>
   <h1>{{welcome}}</h1>
</template>

<script setup>
import { ref } from 'vue'
const welcome = ref(`Welcome ${User.name}`);
</script>