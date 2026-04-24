module.exports = {
    content: [
        "./templates/**/*.html.twig",
        "./assets/**/*.js"
    ],
    theme: {
        extend: {
            keyframes: {
                "fade-out": {
                    "0%": { opacity: "1" },
                    "75%": { opacity: "1" },
                    "100%": { opacity: "0" }
                }
            },
            animation: {
                "fade-out": "fade-out 3s ease-out forwards"
            }
        }
    }
}