export default {
  isEmptyObject(value) {
    // value = {}
    console.log(value)
    return (
      Object.prototype.toString.call(value) === "[object Object]" &&
      JSON.stringify(value) === "{}"
    )
  },
}
