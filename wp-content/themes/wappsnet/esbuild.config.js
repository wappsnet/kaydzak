const { build } = require('esbuild');

const { cssPlugin } = require('./esbuild/css.plugin');
const { dependencies } = require('./package.json');
const tsconfig = require('./tsconfig.json');

const CONFIGS = {
  entryPoints: [
    'index.ts',
    'index.scss',
  ],
  sourceRoot: '.',
  outDirectory: 'build',
  outFile: 'build/main.js',
}

build({
  entryPoints: CONFIGS.entryPoints,
  outdir: CONFIGS.outDirectory,
  sourceRoot: CONFIGS.sourceRoot,
  bundle: true,
  minify: true,
  sourcemap: false,
  preserveSymlinks: true,
  platform: 'neutral',
  format: 'cjs',
  target: 'es6',
  tsconfigRaw: tsconfig,
  external: Object.keys(dependencies),
  loader: {
    '.ts': 'ts',
    '.tsx': 'tsx',
    '.png': 'file',
    '.jpg': 'file',
    '.jpeg': 'file',
    '.svg': 'file',
    '.gif': 'file',
    '.scss': 'file',
  },
  assetNames: '[dir]/[name]',
  plugins: [
    cssPlugin({
      loadPaths: [CONFIGS.sourceRoot],
      rootDir: CONFIGS.sourceRoot,
      outDir: CONFIGS.outDirectory,
    }),
  ],
}).catch(() => process.exit(1));
