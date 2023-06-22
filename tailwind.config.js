module.exports = {
  content: ["./*.php"],
  theme: {
    fontFamily: {
      mont: "Montserrat, sans-serif",
      lato: "Lato, sans-serif",
    },
    screens: {
      sm: "640px",
      md: "768px",
      lg: "1100px",
      xl: "1280px",
      "2xl": "1366px",
    },
    extend: {
      maxWidth: {
        "1366px": "1366px",
      },
      spacing: {
        "52px": "52px",
        "9.6px": "9.6px",
        "136px": "136px",
        "148px": "148px",
        "640px": "640px",
      },
    },
  },
  plugins: [],
};
