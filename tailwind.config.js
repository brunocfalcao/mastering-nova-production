module.exports = {
    "purge": [
        "./resources/views/**/*.blade.php",
        "./resources/css/**/*.css"
    ],
    "theme": {

        "customForms": theme => ({
              default: {
                checkbox: {
                '&:focus': {
                  boxShadow: undefined,
                  borderColor: undefined,
                },
              },
            }
          }),

        "extend": {

            zIndex: {
              '100': 100,
              '200': 200,
              '201': 201
            },

            /* Pading, Margin, Width and Height */
            spacing: {
                "96": "24rem",
                "116": "29rem",
                "120": "30rem",
                "128": "32rem",
                "148": "37rem",
                "152": "38rem",
                "156": "39rem",
                "256": "64rem",
            },

            screens: {
                  "sm": "640px",
                  // => @media (min-width: 640px) { ... }

                  "md": "768px",
                  // => @media (min-width: 768px) { ... }

                  "lg": "1024px",
                  // => @media (min-width: 1024px) { ... }

                  "xl": "1280px",
                  // => @media (min-width: 1280px) { ... }

                  "hd": "1441px",
                  // => @media (min-width: 1440px) { ... }
                },

            opacity: {
                "66": ".66",
                "33": ".33",
                "90": ".90",
                "10": ".10"
            },

            fontFamily: {
                "body": 'nunito, system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
                "code": '"Fira Code", system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol", "Noto Color Emoji"',
            },

            textColor: {
                "twitter": "#38A1F3",
                "github": "#24292E"
            },

            borderColor: {
                "twitter": "#38A1F3",
                "github": "#24292E"
            },

            "colors": {
                "richblack": {
                    "100": "#CFDCF4",
                    "200": "#A2B9E9",
                    "300": "#6782BF",
                    "400": "#364A7F",
                    "500": "#0A122A",
                    "600": "#070D24",
                    "700": "#050A1E",
                    "800": "#030618",
                    "900": "#010414"
                },
            },
        },
    },
    "variants": {},
    plugins: [
      require('@tailwindcss/custom-forms')
    ]
}

