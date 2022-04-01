const path = require("path")

module.exports = {
  output: {
    chunkFilename: "js/[name].js",
  },
  resolve: {
    extensions: [".vue"],
    alias: {
      "@": path.resolve("resources/js"),
      "@components": path.resolve("resources/js/Components"),
      "@layouts": path.resolve("resources/js/Layouts"),
      "@pages": path.resolve("resources/js/Pages"),
    },
  },
}
