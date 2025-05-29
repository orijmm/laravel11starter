<template>
    <!-- Codigo html -->
  </template>
  
  <script>
  import { trans } from "@/helpers/i18n";
  
  export default {
    props: {
      content: {
        type: [Array],
        default: [],
      },
      services: {
        type: [Array],
        default: [],
      },
      img: {
        type: String,
        default: [],
      }
    },
    setup(props) {
  
      return {
        trans,
      }
    }
  }
  </script>
  