import { defineConfig } from "vitest/config";
import Vue from "@vitejs/plugin-vue";
import path from "path";

export default defineConfig({
  plugins: [Vue()],
  test: {
    globals: true,
    environment: "jsdom",
  },

  root:  path.resolve(__dirname, './resources/js/tests'),

  resolve: {
    alias: {
      '@' : path.resolve(__dirname, './resources/js')
    },
  }
});
