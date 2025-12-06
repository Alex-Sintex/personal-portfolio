const { defineConfig } = require('@vue/cli-service')

module.exports = defineConfig({
  transpileDependencies: true,
  pwa: {
    name: 'PWA',
    themeColor: '#33ff44',
    backgroundColor: '#ccc'
  }
})
