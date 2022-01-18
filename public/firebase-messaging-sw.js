self.addEventListener("push", function (event) {
    var title = event.data.json().notification.title;
    var body = event.data.json().notification.body;
    var icon = event.data.json().notification.icon; //custom icon
    var click_action = event.data.json().data.url; //custom link
    console.log(event.data.json().data);

    event.waitUntil(
        self.registration.showNotification(title, {
            body: body,
            sound: 'default',
            data: {
                url: click_action,
                icon: icon,
            }
        })
    );
});

self.addEventListener("notificationclick", function (event) {
    console.log(event.notification.data);
    event.notification.close();
    event.waitUntil(clients.openWindow(event.notification.data.url));
});
