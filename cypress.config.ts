import { defineConfig } from 'cypress';
import installCypressLogsPrinter from 'cypress-terminal-report/src/installLogsPrinter';
const envLogDir = process.env.LOG_DIR ? process.env.LOG_DIR + '/GuidedTour' : null;

export default defineConfig( {
	e2e: {
		baseUrl: process.env.MW_SERVER + process.env.MW_SCRIPT_PATH,
		setupNodeEvents( on ) {
			installCypressLogsPrinter( on );
		},
	},
	screenshotsFolder: envLogDir || 'cypress/screenshots',
	videosFolder: envLogDir || 'cypress/videos',
	video: true,
	downloadsFolder: envLogDir || 'cypress/downloads',
} );
