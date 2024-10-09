import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue';
import { resolve } from 'path';
import AutoImport from 'unplugin-auto-import/vite';

// https://vitejs.dev/config/
export default defineConfig({
  plugins: [
      AutoImport({
        imports: [
            'vue',
        ]
      }),
      vue(),
  ],
  resolve: {
    alias: {
      '@': resolve(__dirname, 'src'),             // Общий алиас для src
      '@domain': resolve(__dirname, 'src/domain'),        // Для доменного слоя
      '@application': resolve(__dirname, 'src/application'), // Для слоя приложений
      '@infrastructure': resolve(__dirname, 'src/infrastructure'), // Для инфраструктуры
      '@interfaces': resolve(__dirname, 'src/interfaces'),  // Для интерфейсов и UI
      '@shared': resolve(__dirname, 'src/shared')   // Для общих утилит и констант
    }
  },
})
