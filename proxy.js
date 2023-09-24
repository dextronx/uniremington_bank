const express = require('express');
const { createProxyMiddleware } = require('http-proxy-middleware');

const app = express();

app.use('/credit_card_api', createProxyMiddleware({ target: 'http://192.168.1.12', changeOrigin: true }));
app.listen(3000);