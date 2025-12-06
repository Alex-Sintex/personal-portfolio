import PropExample from "@/components/PropExample.vue";
import { mount } from "@vue/test-utils";

describe("PropExample.vue", () => {
  it("receives and shows title and content props", () => {
    const wrapper = mount(PropExample, {
      props: {
        title: "Hello World",
        content: "Lorem ipsum",
      },
    });

    // Assertions should be direct, no if statements
    expect(wrapper.find("h3").exists()).toBe(true);
    expect(wrapper.find("h3").text()).toBe("Hello World");

    expect(wrapper.find("p").exists()).toBe(true);
    expect(wrapper.find("p").text()).toBe("Lorem ipsum");
  });
  it("the component emits the counter value", async () => {
    const wrapper = mount(PropExample, {
      props: {
        title: "Hello World",
        content: "Lorem ipsum",
      },
    });
    await wrapper.find("button").trigger("click");
    expect(wrapper.emitted().clickMe[0][0]).toBe(1);
  });
});
