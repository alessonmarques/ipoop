
const IPoopMapIcons = {
    restroomIcons: {},
    userIcons: {},
    restroomTypes: {
        0: 'banheiro-privado',
        1: 'banheiro-publico',
    },
    accessibility: {
        0: false,
        1: true,
    },
    rating: {
        0: '0estrelas',
        1: '1estrelas',
        2: '2estrelas',
        3: '3estrelas',
        4: '4estrelas',
        5: '5estrelas',
    },
    userType: {
        0: 'user-anonimo',
        1: 'user-autenticado',
    },
    setIcons() {
        this.restroomIcons = this.getRestroomIcons();
        this.userIcons = this.getUserIcons();
    },
    getUserIcons() {
        let userIcons = {};
        Object.values(this.userType).forEach((iconName) => {
            const url = `svg/user/${iconName}.svg`;
            userIcons[iconName] = {
                iconUrl: url,
                iconSize: [48, 64],
                iconAnchor: [24, 64],
                popupAnchor: [0, -64],
            };
        });

        return userIcons;
    },
    getRestroomIcons() {
        let restroomIcons = {};
        Object.values(this.restroomTypes).forEach(type => {
            Object.values(this.accessibility).forEach(accessible => {
                Object.values(this.rating).forEach(rating => {
                    const iconFileName = `${type}${accessible ? '-acessivel' : ''}-${rating}`;
                    const url = `/svg/restrooms/${iconFileName}.svg`;
                    restroomIcons[iconFileName] = L.icon({
                        iconUrl: url,
                        iconSize: [48, 64],
                        iconAnchor: [24, 64],
                        popupAnchor: [0, -64],
                    });
                });
            });
        });
        return restroomIcons;
    },
    getRestroomIcon(typeIdx, accessibilityIdx, ratingIdx) {
        const iconName = `${this.restroomTypes[typeIdx]}${this.accessibility[accessibilityIdx] ? '-acessivel' : ''}-${this.rating[ratingIdx]}`;
        if (!this.restroomIcons[iconName]) {
            console.error(`Icon not found: ${iconName}`);
            return null;
        }
        return this.restroomIcons[iconName];
    },
}

export default IPoopMapIcons;