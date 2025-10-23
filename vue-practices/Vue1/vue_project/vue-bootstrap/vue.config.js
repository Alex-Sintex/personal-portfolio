const { defineConfig } = require('@vue/cli-service')
module.exports = defineConfig({
  devServer: {
    // Enable WebSocket connection
    client: {
      webSocketURL: 'ws://localhost:8080/ws',
    },
  },
  transpileDependencies: true
})
