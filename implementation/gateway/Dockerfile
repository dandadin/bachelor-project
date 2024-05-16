# alternative build environment
#FROM frolvlad/alpine-gxx AS dev
#COPY src /root/src
#COPY Makefile /root
#RUN apk add make
#RUN apk add mosquitto-dev rapidjson-dev
#RUN cd /root && make clean && make

FROM gcc:12.3.0 AS dev
COPY src /root/src
COPY Makefile /root
RUN apt update
RUN apt install -y libmosquitto-dev rapidjson-dev
RUN cd /root && make clean && make

# debian:12.5 has the same libc version as gcc:12.3.0
#FROM alpine:3.19.1
FROM debian:12.5
RUN apt update \
    && apt install -y libmosquitto-dev rapidjson-dev
RUN mkdir -p /opt/gateway
COPY --from=dev /root/bin/* /opt/gateway/
COPY gateway_default_config.json /opt/gateway/default_config.json
WORKDIR /opt/gateway
CMD /opt/gateway/gateway /opt/gateway/default_config.json
