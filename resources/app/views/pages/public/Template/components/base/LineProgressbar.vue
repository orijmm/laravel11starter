<template>
  <svg
    ref="targetElement"
    viewBox="0 0 100 6"
    preserveAspectRatio="none"
    :style="{ display: 'block', width: `${counted}%` }"
  >
    <path
      d="M 0,3 L 100,3"
      stroke="#eee"
      stroke-width="6"
      fill-opacity="0"
    ></path>
    <path
      d="M 0,3 L 100,3"
      stroke="#555"
      stroke-width="6"
      fill-opacity="0"
      style="stroke-dasharray: 100, 100; stroke-dashoffset: 0"
    ></path>
  </svg>
  <div
    class="progressbar-text"
    style="
      color: inherit;
      position: absolute;
      right: 0px;
      top: -30px;
      padding: 0px;
      margin: 0px;
    "
  >
    {{ counted }} %
  </div>
</template>

<script setup>
const targetElement = ref();
const props = defineProps(["max"]);

const counted = ref(0);
const startCountup = () => {
  const intervalId = setInterval(() => {
    counted.value += 1;

    // Check if counted.value has reached a specific value (e.g., props.max)
    if (counted.value >= props.max) {
      // Stop the interval if the condition is met
      clearInterval(intervalId);
    }
  }, 2000 / props.max);
};
onMounted(() => {
  function handleIntersection(entries, observer) {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        startCountup();
        observer.unobserve(entry.target);
        // Do something when the observed element enters the viewport
      }
    });
  }

  // Options for the Intersection Observer
  const options = {
    root: null, // Use the viewport as the root
    rootMargin: "0px", // No margin around the root
    threshold: 0.5, // Trigger when 50% of the observed element is visible
  };

  // Create an Intersection Observer and pass in the callback function and options
  const observer = new IntersectionObserver(handleIntersection, options);

  // Start observing the target element

  observer.observe(targetElement.value);
});
</script>

