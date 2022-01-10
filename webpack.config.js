const path = require("path");

module.exports = {
  resolve: {
    alias: {
      "@": path.resolve("resources/js"),
      "@components": path.resolve("resources/js/Components"),
      "@layouts": path.resolve("resources/js/Layouts"),
      "@pages": path.resolve("resources/js/Pages"),
    },
  },
};
