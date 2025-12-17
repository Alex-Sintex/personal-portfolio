const { defineConfig } = require("@vue/cli-service");
module.exports = defineConfig({
  devServer: {
    client: {
      webSocketURL: "ws://localhost:8080/ws",
    },
  },
  transpileDependencies: true,
  publicPath: process.env.PUBLIC_HTML || "/",
});
