module.exports = function(api) {
  api.cache(true);
  return {
    presets: ['babel-preset-expo'],
    plugins: [
      [
        'module-resolver',
        {
          root: ['./'],
          extensions: ['.ios.js', '.android.js', '.js', '.ts', '.tsx', '.json'],
          alias: {
            '@': './src',
            '@components': './src/components',
            '@screens': './src/screens',
            '@theme': './src/theme',
            '@utils': './src/utils',
            '@services': './src/services',
            '@navigation': './src/navigation',
          },
        },
      ],
      'react-native-reanimated/plugin',
    ],
  };
};
