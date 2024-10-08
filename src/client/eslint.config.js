import { FlatCompat } from '@eslint/eslintrc';
import vue from 'eslint-plugin-vue';
import typescriptEslint from '@typescript-eslint/eslint-plugin';
import eslintPluginImport from 'eslint-plugin-import';

const compat = new FlatCompat({
    baseDirectory: process.cwd(),
    recommendedConfig: true,
});

export default [
    {
        files: ['**/*.vue'],
        languageOptions: {
            parser: 'vue-eslint-parser',
            parserOptions: {
                parser: '@typescript-eslint/parser',
                ecmaVersion: 2021,
                sourceType: 'module',
            },
        },
        plugins: {
            vue,
            '@typescript-eslint': typescriptEslint,
        },
        rules: {
            '@typescript-eslint/explicit-module-boundary-types': 'off',
            '@typescript-eslint/no-explicit-any': 'warn',
            'vue/multi-word-component-names': 'off',
            'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
            'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
        },
    },
    {
        files: ['**/*.ts', '**/*.js'],
        languageOptions: {
            parser: '@typescript-eslint/parser',
            ecmaVersion: 2021,
            sourceType: 'module',
        },
        plugins: {
            '@typescript-eslint': typescriptEslint,
            import: eslintPluginImport,
        },
        rules: {
            '@typescript-eslint/explicit-module-boundary-types': 'off',
            '@typescript-eslint/no-explicit-any': 'warn',
            'import/order': [
                'error',
                {
                    groups: [['builtin', 'external', 'internal']],
                    'newlines-between': 'always',
                },
            ],
            'no-console': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
            'no-debugger': process.env.NODE_ENV === 'production' ? 'warn' : 'off',
        },
    },
    {
        settings: {
            'import/resolver': {
                alias: {
                    map: [
                        ['@', './src'],
                        ['@domain', './src/domain'],
                        ['@application', './src/application'],
                        ['@infrastructure', './src/infrastructure'],
                        ['@interfaces', './src/interfaces'],
                        ['@shared', './src/shared'],
                    ],
                    extensions: ['.ts', '.vue', '.js'],
                },
            },
        },
    },
    ...compat.extends('plugin:vue/vue3-recommended'),
    ...compat.extends('plugin:@typescript-eslint/recommended'),
];
