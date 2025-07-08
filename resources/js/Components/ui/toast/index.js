export { default as Toast } from './Toast.vue';
export { default as ToastAction } from './ToastAction.vue';
export { default as ToastClose } from './ToastClose.vue';
export { default as ToastDescription } from './ToastDescription.vue';
export { default as Toaster } from './Toaster.vue';
export { default as ToastProvider } from './ToastProvider.vue';
export { default as ToastTitle } from './ToastTitle.vue';
export { default as ToastViewport } from './ToastViewport.vue';
export { toast, useToast } from './use-toast';

import { cva } from 'class-variance-authority';

export const toastVariants = cva(
  'group pointer-events-auto relative flex w-full items-center justify-between space-x-2 overflow-hidden rounded-md border p-4 pr-6 shadow-lg transition-all data-[swipe=cancel]:translate-x-0 data-[swipe=end]:translate-x-[var(--reka-toast-swipe-end-x)] data-[swipe=move]:translate-x-[var(--reka-toast-swipe-move-x)] data-[swipe=move]:transition-none data-[state=open]:animate-in data-[state=closed]:animate-out data-[swipe=end]:animate-out data-[state=closed]:fade-out-80 data-[state=closed]:slide-out-to-right-full data-[state=open]:slide-in-from-top-full data-[state=open]:sm:slide-in-from-bottom-full',
  {
    variants: {
      variant: {
        default: 'border bg-background text-foreground',
        destructive: 'destructive group border-destructive bg-destructive text-destructive-foreground',
        success: 'border-green-200 bg-green-50 text-green-800 dark:bg-green-900 dark:text-green-100',
        warning: 'border-yellow-200 bg-yellow-50 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100',
        info: 'border-blue-200 bg-blue-50 text-blue-800 dark:bg-blue-900 dark:text-blue-100',
        muted: 'border-gray-200 bg-gray-50 text-gray-600 dark:border-gray-700 dark:bg-gray-800 dark:text-gray-300',
        primary: 'border-primary bg-primary text-primary-foreground',
        secondary: 'border-secondary bg-secondary text-secondary-foreground',
        accent: 'border-accent bg-accent text-accent-foreground',
        outline: 'border-2 bg-transparent',
      },
      size: {
        sm: 'p-2 pr-4 text-sm',
        default: 'p-4 pr-6',
        lg: 'p-6 pr-8 text-lg',
      },
      position: {
        topRight: 'origin-top-right',
        topCenter: 'origin-top',
        topLeft: 'origin-top-left',
        bottomRight: 'origin-bottom-right',
        bottomCenter: 'origin-bottom',
        bottomLeft: 'origin-bottom-left',
      },
    },
    defaultVariants: {
      variant: 'default',
      size: 'default',
      position: 'bottomRight',
    },
  },
);
