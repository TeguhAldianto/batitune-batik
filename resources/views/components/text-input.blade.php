@props(['disabled' => false])

<input @disabled($disabled)
    {{ $attributes->merge(['class' => 'w-full rounded-lg border border-gray-200 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:ring-2 focus:ring-orange-500 focus:border-orange-500 dark:focus:ring-orange-500 dark:focus:border-orange-500 transition ease-in-out duration-150 px-3 py-2']) }}>
