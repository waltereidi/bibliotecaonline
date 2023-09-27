"use strict";
var __importDefault = (this && this.__importDefault) || function (mod) {
    return (mod && mod.__esModule) ? mod : { "default": mod };
};
Object.defineProperty(exports, "__esModule", { value: true });
const store_ts_1 = require("@/store.ts");
const Livros_vue_1 = __importDefault(require("@/components/Livros/Livros.vue"));
const vue_esm_bundler_1 = require("vue/dist/vue.esm-bundler");
const livros = (0, vue_esm_bundler_1.createApp)();
livros.component('livros', Livros_vue_1.default);
livros.use(store_ts_1.store);
livros.mount('#livros');
