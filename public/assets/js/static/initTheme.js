// const body = document.body;
// const theme = localStorage.getItem('theme')

// if (theme) 
//   document.documentElement.setAttribute('data-bs-theme', theme)
const prefersColorScheme = window.matchMedia('(prefers-color-scheme: dark)');
if( prefersColorScheme.matches ) {
  document.body.classList.add('theme-dark');
} else {
    document.body.classList.remove('theme-dark');
}