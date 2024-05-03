/** @type {import('tailwindcss').Config} */
module.exports = {
	content: ['./src/**/*.{astro,html,js,jsx,md,mdx,svelte,ts,tsx,vue}', "./node_modules/flowbite/**/*.js"],
	darkMode: 'class',
	theme: {
		extend: {
			backgroundImage: {
				'custom-bg': `url('/public/background/bg2.png')`,
				'custom-test': `url('/public/background/bg3.webp')`,
				'airplane-bg': `url('/public/background/airplane.webp')`,
			},
		},
	},
	plugins: [
		require('tailwindcss'),
		require('autoprefixer'),
	],
}