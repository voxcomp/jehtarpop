const fs = require('fs');
const glob = require('glob');

// Patterns to look for
const patterns = [
    { regex: /\bbtn-block/g, replace: 'd-block w-100' },
    { regex: /\b(jQuery)/g, replace: 'remove' },
    { regex: /\bml-\d+/g, replace: 'ms-*' },
    { regex: /\bmr-\d+/g, replace: 'me-*' },
    { regex: /\bpl-\d+/g, replace: 'ps-*' },
    { regex: /\bpr-\d+/g, replace: 'pe-*' },
    { regex: /data-toggle=/g, replace: 'data-bs-toggle=' },
    { regex: /data-target=/g, replace: 'data-bs-target=' },
    { regex: /custom-file/g, replace: 'new file input markup' },
    { regex: /card-deck/g, replace: 'row + col' }
];

// Use glob with a callback (v7 syntax)
glob("resources/views/**/*.blade.php", {}, function (err, files) {
    if (err) throw err;

    files.forEach(file => {
        const content = fs.readFileSync(file, 'utf8');
        let found = false;

        patterns.forEach(p => {
            const matches = content.match(p.regex);
            if (matches) {
                if (!found) {
                    console.log(`\nFile: ${file}`);
                    found = true;
                }
                matches.forEach(m => {
                    console.log(`  Found: "${m}" → should update to "${p.replace}"`);
                });
            }
        });
    });

    console.log('\nBootstrap 4 scan complete.');
});

