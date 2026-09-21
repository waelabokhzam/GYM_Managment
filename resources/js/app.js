
const html = document.documentElement;

const savedTheme = localStorage.getItem('gym-theme');

if (savedTheme === 'light') {
    html.classList.add('light');
}