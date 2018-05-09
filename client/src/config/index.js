export default {
  consoleOutput: true,
  apiGraphQL: 'http://localhost:8000/graphql',
  backendUrl: '/backend',
  localStorage: {
    enableListener: false,
    unauthChange: 'block' // block or clear
  },
  session: {
    tokenName: 'Laqul',
    refreshTokenMargin: 30
  },
  firebase: {
    enabled: true,
    fcm: { // Firebase Cloud Messaging
      enabled: true, // Activa la funcion de notificaciones en la aplicacion
      maxNotifications: 10 // Numero de notificaciones en la aplicacion (maximo 20)
    },
    config: {
      apiKey: 'YOUR_FIREBASE_API_KEY',
      authDomain: 'YOUR_FIREBASE_AUTH_DOMAIN',
      databaseURL: 'YOUR_FIREBASE_DATABASE_URL',
      projectId: 'YOUR_FIREBASE_PROJECT_ID',
      storageBucket: 'YOUR_FIREBASE_STORAGE_BUCKET',
      messagingSenderId: 'YOUR_FIREBASE_SENDER_ID'
    }
  },
  language: {
    multilanguage: true,
    languages: [
      { name: 'Espanol', active: true, code: 'es' },
      { name: 'Ingles', active: true, code: 'en-us' }
    ]
  }
}
