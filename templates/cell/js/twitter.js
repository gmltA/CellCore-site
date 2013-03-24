<script src="http://widgets.twimg.com/j/2/widget.js"></script>
<script>
        new TWTR.Widget({
          version: 2,
          type: 'profile',
          rpp: 5,
          interval: 30000,
          width: 260,
          height: 400,
          theme: {
            shell: {
              background: '#2b2b2b',
              color: '#ffffff'
            },
            tweets: {
              background: '#000000',
              color: '#ffffff',
              links: '#05a8ed'
            }
          },
          features: {
            scrollbar: false,
            loop: false,
            live: false,
            hashtags: true,
            timestamp: true,
            avatars: false,
            behavior: 'all'
          }
        }).render().setUser('CellCoreProject').start();
</script>