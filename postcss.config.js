let tailwind = require("tailwindcss");

module.exports = {
  plugins: [
    tailwindcss('./tailwind.config.js'),
    require('postcss-import'),
    require('autoprefixture')
  ],
}
