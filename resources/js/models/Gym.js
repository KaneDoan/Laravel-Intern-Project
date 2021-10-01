import Model from "./Model";
import Media from "./Media";

export default class Gym extends Model {
    resource() {
        return "gyms";
    }

    media() {
        return this.hasMany(Media)
    }
}
