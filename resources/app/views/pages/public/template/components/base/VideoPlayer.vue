<template>
    <video
      style="
        width: 100%;

        position: relative;
        border-radius: 4px;
        max-height: 300px;
        overflow: hidden;
      "
      ref="videoPlayer"
      class="video-js"
    ></video>
</template>

<script setup>
import videojs from "video.js";
import { ref, onMounted, onBeforeUnmount } from "vue";

// Definir las propiedades
const props = defineProps(["options", "videopath"]);
const videoPlayer = ref();

// Definir las opciones por defecto del video
const defaultVideoOption = {
  autoplay: false,
  controls: true,
  sources: [
    {
      src: props.videopath,
      type: getMimeType(props.videopath),
    },
  ],
};

const player = ref(null);

// Inicializar el reproductor de video cuando el componente esté montado
onMounted(() => {
  console.log(getMimeType(props.videopath), 'getMimeType(props.videopath)');
  player.value = videojs(
    videoPlayer.value,
    props.options || defaultVideoOption,
    () => { }
  );
});

// Limpiar el reproductor cuando el componente se desmonte
onBeforeUnmount(() => {
  if (player.value) {
    player.value.dispose();
  }
});

function getMimeType(path) {
  const ext = path.split('.').pop().toLowerCase();
  switch (ext) {
    case 'mp4':
      return 'video/mp4';
    case 'webm':
      return 'video/webm';
    case 'ogg':
      return 'video/ogg';
    case 'mov':
      return 'video/quicktime';
    default:
      return 'video/mp4';
  }
}

</script>

<style>
@import "video.js/dist/video-js.css";

.video-js>* {
  z-index: 120;
}
</style>
