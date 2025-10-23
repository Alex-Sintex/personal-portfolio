const webpack = require('webpack'); // Import webpack

module.exports = {
  devServer: {
    // Enable WebSocket connection
    client: {
      webSocketURL: 'ws://localhost:8080/ws',
    },
  },
  configureWebpack: {
    plugins: [
      new webpack.DefinePlugin({
        __VUE_PROD_HYDRATION_MISMATCH_DETAILS__: JSON.stringify(false), // or true
      }),
    ],
  },
  transpileDependencies: true
};
