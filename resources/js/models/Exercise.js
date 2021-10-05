import Model from "./Model";
import Media from "./Media";

export default class Exercise extends Model {

    resource() {
        return "exercises";
    }

    media() {
        return this.hasMany(Media)
    }

}
