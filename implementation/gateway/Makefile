CFLAGS=-std=c++20 -g
OBJS = $(patsubst %.cpp,%.o,$(wildcard src/*.cpp))
MODS = $(patsubst src/modules/%.cpp,bin/%.so,$(wildcard src/modules/*.cpp))
DEPFLAGS = -MT $@ -MMD -MP -MF $@.d

all: gateway modules

gateway: bin/gateway
modules: $(MODS) 
  
bin/gateway: $(OBJS)
	mkdir -p bin
	g++ $(CFLAGS) $^ -o $@ -Wl,-E -lmosquitto

%.o: %.cpp
	g++ $(CFLAGS) $(DEPFLAGS) -c $< -o $@

bin/%.so: src/modules/%.cpp src/device.h
	mkdir -p bin
	g++ $(CFLAGS) -shared -fPIC $< -o $@ -iquote src

clean:
	rm -f ./gateway src/*.o bin/* $(MODS)

-include src/*.d
