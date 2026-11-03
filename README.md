# PingDoot website — plain HTML, CSS and JavaScript

A responsive, multi-page static website using the supplied PingDoot logo. It does not require React, TypeScript, Vite, Node.js, a database, or a VPS to host.

## Preview
Open `index.html` in a browser, or run `python -m http.server 8080` from this folder and visit `http://localhost:8080`.

## Deploy to Hostinger / GoDaddy
1. Extract the ZIP.
2. Upload the project contents to your hosting document root (usually `public_html`). Keep `css/`, `js/`, `assets/`, all `.html` pages, and `favicon.svg` together.
3. Enable HTTPS and point the domain to the hosting account.
4. Test the homepage and inner-page URLs. All pages use direct `.html` URLs.

## Edit the site
- `css/styles.css`: design tokens, layout, colours and responsive behaviour.
- `js/app.js`: navigation, homepage sections, carousel, shared header/footer, and form behaviour.
- `js/content.js`: content for inner pages.
- `assets/pingdoot-logo.png`: cropped version of the supplied logo.

## Images
The hero carousel and supporting photography use Unsplash image URLs and therefore require internet access in the visitor's browser. Replace those URLs in `js/app.js` with locally licensed images in `assets/` if fully offline/locally bundled imagery is preferred.

## Forms
The form performs browser-side required-field validation only. It is not connected to a submission service and deliberately does not show a false success message. Configure a secure form endpoint or backend before collecting enquiries. Never add API secrets to client-side code.

## Before publication
Confirm the official business email, phone, domain, legal entity, social links, and available product capabilities. Review the starter Privacy, Terms and Cookie pages with qualified counsel before publication. No address, testimonials, certifications, customer logos, or performance statistics have been invented.
