Nova.booting((Vue, router, store) => {
  router.addRoutes([
    {
      name: 'nova-stats-tracker',
      path: '/nova-stats-tracker',
      component: require('./components/Tool'),
    },
  ])
})
