import { defineConfig } from "vite";
import path from "path";

export default defineConfig({
  build: {
    lib: {
      entry: path.resolve(__dirname, "./public/js/main.js"),
      name: "framework ESGI",
      //formats: ["es"],
    },
  }, // ...
});