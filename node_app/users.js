/**
 * Created by abderrahimelimame on 9/24/16.
 */
module.exports = function () {
    /**
     * available users
     * the id value is considered unique (provided by socket.io)
     */
    var usersList = [];

    /**
     * User object
     */
    var User = function (id, connected, socketID) {
        this.connected = connected;
        this.ID = id;
        this.socketID = socketID
    };

    return {
        addUser: function (id, connected, socketID) {
            var user = new User(id, connected, socketID);
            usersList.push(user);
        },

        removeUser: function (id) {
            var index = 0;
            while (index < usersList.length && usersList[index].ID != id) {
                index++;
            }
            usersList.splice(index, 1);
        },

        updateUser: function (id, connected, socketID) {
            var user = usersList.find(function (element, i, array) {
                return element.ID == id;
            });
            user.connected = connected;
            user.socketID = socketID;
        },

        getUser: function (id) {
            return usersList.find(function (element, i, array) {
                return element.ID == id;
            });
        },
        getUserBySocketID: function (socketID) {
            return usersList.find(function (element, i, array) {
                return element.socketID == socketID;
            });
        },

        getUsers: function () {
            return usersList;
        }
    }
};