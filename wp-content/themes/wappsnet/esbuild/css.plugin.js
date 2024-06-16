const cssPlugin = ({ loadPaths, rootDir, outDir }) => ({
  name: 'css',
  setup: (build) => {
    const sass = require('sass');

    build.onResolve({ filter: /\.scss$/ }, (args) => {
      const path = require('path');

      return {
        path: path.join(args.resolveDir, args.path),
      };
    });

    build.onLoad({ filter: /\.scss$/ }, (args) => {
      const result = sass.compile(args.path, {
        loadPaths,
        sourceMap: true,
      });

      return {
        contents: result.css.toString(),
        loader: 'css',
      };
    });
  },
});

module.exports = {
  cssPlugin,
};
