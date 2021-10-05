import Model from "./Model";
import Media from "./Media";

export default class Routine extends Model {

    resource() {
        return "routines";
    }

    media() {
        return this.hasMany(Media)
    }
}
