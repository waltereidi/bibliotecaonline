import { createApp } from 'vue/dist/vue.esm-bundler';
import testPageComponent from "@/components/Tests/testPage.vue";

const testPage = createApp();
testPage.component('test-page', testPageComponent);
testPage.mount('#testPage');
