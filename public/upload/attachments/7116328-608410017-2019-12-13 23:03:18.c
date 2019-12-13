#include <stdio.h>
#include <math.h>
#include <string.h>
#include <stdlib.h>
#include "pattern.h"
struct instruction{
	int method;
	char tag[32];
	char index[32];
	char offset[32];
};
struct cache{
	int ins;
	int valid;
	int dirty;
	char tag[32];
	char data[32];
};
struct instruction ins[10000000];
struct cache cach[10000000];
int FIFO_point[10000000]={0};
void initial(){
	for(int i=0;i<10000000;i++){
		ins[i].method=0;
		memset(ins[i].tag,0,32);
		memset(ins[i].index,0,32);
		memset(ins[i].offset,0,32);
		cach[i].ins=0;
		cach[i].valid=0;
		cach[i].dirty=0;
		memset(cach[i].tag,0,32);
		memset(cach[i].data,0,32);
	}
}
int hit(int cacheIdx,int assoc,int demandFetch,int tag){
    cacheIdx=cacheIdx*assoc;
    for(int i=0;i<assoc;i++){
        if(cach[cacheIdx+i].valid&&strncmp(cach[cacheIdx+i].tag,ins[demandFetch].tag,tag)==0){
            return cacheIdx+i;
        }
    }
    return -1;
}
void rmNewLine(char *line){
	int i=0;
	while(line[i]!='\0'&&line[i]!='\n'){
		i++;
	}
	line[i]='\0';
}
int FIFO(int cacheIdx,int assoc){
    cacheIdx=cacheIdx*assoc;
    if(FIFO_point[cacheIdx]+1==assoc){
        FIFO_point[cacheIdx]=-1;
    }
    FIFO_point[cacheIdx]++;
    return FIFO_point[cacheIdx]+cacheIdx;
}
int LRU(int cacheIdxBase, int assoc){
    
    /* Least Recent Usage */
    
    cacheIdxBase *= assoc;
    
    int min = 1000000000, minCacheBlock = -1;
    
    for (int i = 0; i < assoc; i++) {
        
        /* Find the space first; if not, apply the LRU alg */
        
        if (cach[cacheIdxBase + i].valid == 0) {
            
            return (cacheIdxBase + i);
            
        }else if (cach[cacheIdxBase + i].ins < min) {
            
            min = cach[cacheIdxBase + i].ins;//ä»¥demandFetch?²ä??„æ??“é??ºæ?
            
            minCacheBlock = cacheIdxBase + i;
            
        }
    }
    
    return minCacheBlock;
    
}
int replacePolicy(int replace,int cacheIdx,int assoc){
    if(replace==1){
        return FIFO(cacheIdx,assoc);
    }
    else if(replace==2){
        return LRU(cacheIdx,assoc);
    }
    return -1;
}
void Way(int demandFetch,int replace,int assoc,int *bytesfrom,int *bytesto,int index,int tag,int *cacheHit,int *cacheMiss,int blockSize){
    int cacheIdx=binary_to_int(ins[demandFetch].index,index);
    //printf("%d\n",cacheIdx);
    int hitted=hit(cacheIdx,assoc,demandFetch,tag);
    //printf("%d\n",hitted);
    if(hitted!=-1){
        (*cacheHit)++;
        cach[hitted].ins=demandFetch;
        if(ins[demandFetch].method=='0'||ins[demandFetch].method=='2'){
            return;
        }
        else if(ins[demandFetch].method=='1'){
            cach[hitted].dirty=1;
        }
    }
    else{
        (*cacheMiss)++;
        int target=replacePolicy(replace,cacheIdx,assoc);
        //printf("%d\n",target);
        if(cach[target].dirty==1){
            (*bytesto)+=blockSize;
        }
        (*bytesfrom)+=blockSize;
        cach[target].valid=1;
        strncpy(cach[target].tag,ins[demandFetch].tag,tag);
        cach[target].ins=demandFetch;
        //printf("%d\n",target);
        if(ins[demandFetch].method=='0'||ins[demandFetch].method=='2'){
            cach[target].dirty=0;
        }
        else if(ins[demandFetch].method=='1'){
            cach[target].dirty=1;
        }
    }
}
void clean(int *bytesto,int blockSize){//remaing for dirty==1
    for(int i=0;i<1000000;i++){
        if(cach[i].dirty==1){
            (*bytesto)+=blockSize;
        }
    }
}
int main(int argc,char *argv[]){
	int cacheSize,blockSize,associate,replace;
	int demandFetch,cacheHit,cacheMiss,readData,writeData,bytesfrom,bytesto;
    bytesfrom=0;
    bytesto=0;
	demandFetch=0;
    readData=0;
    cacheHit=0;
    cacheMiss=0;
    writeData=0;
	cacheSize=atoi(argv[1]);
	blockSize=atoi(argv[2]);
	if(strcmp(argv[3],"1")==0){
			associate=1;	
					}
	else if(strcmp(argv[3],"2")==0){
		associate=2;
	}
	else if(strcmp(argv[3],"4")==0){
		associate=4;
	}
	else if(strcmp(argv[3],"8")==0){
		associate=8;
	}
	else if(strcmp(argv[3],"f")==0){
		associate=(cacheSize*1024)/blockSize;
	}
	if(strcmp(argv[4],"FIFO")==0){
		replace=1;
	}
	else if(strcmp(argv[4],"LRU")==0){
		replace=2;
	}
	FILE *fp=fopen(argv[5],"r");
	int addrIndex=log2((cacheSize*1024)/(blockSize*associate));
	int offset=log2(blockSize);
	int index=addrIndex;
	int cacheTotalindex=pow(2,index);
	int tag=32-(addrIndex+offset);
	char input[20];
	initial();
	while(fgets(input,20,fp)){
		rmNewLine(input);
        if(input[0]!='1'&&input[0]!='2'&&input[0]!='0'){
            continue;
        }
		char *Address=(char *)malloc(sizeof(char)*32);
		memset(Address,0,32);
		int length=strlen(input);
		ins[demandFetch].method=input[0];
		if(input[0]=='2'){
			strcat(Address,"00000000");
		}
		for(int i=2;i<length;i++){
			strcat(Address,hex_to_binary(input[i]));
        }
           // printf("%s\n",Address);
		strncpy(ins[demandFetch].tag,Address,tag);
        strncpy(ins[demandFetch].index,Address+tag,index);
        strncpy(ins[demandFetch].offset,Address+tag+index,offset);
        //printf("%d\n",offset);
        if(ins[demandFetch].method=='0'){
            readData++;
        }
        else if(ins[demandFetch].method=='1'){
            writeData++;
        }
        Way(demandFetch,replace,associate,&bytesfrom,&bytesto,index,tag,&cacheHit,&cacheMiss,blockSize);
		demandFetch++;
        
	}
    clean(&bytesto,blockSize);
	double missRate=(double)cacheMiss/(double)demandFetch;
	printf("Input file = %s\n",argv[5]);
	printf("Demand fetch = %d\n",demandFetch);
    printf("Cache Hit = %d\n",cacheHit);
	printf("Cache miss = %d\n",cacheMiss);
	printf("Miss rate = %.4f\n",missRate);
	printf("Read data = %d\n",readData);
	printf("Write data = %d\n",writeData);
	printf("Bytes from memory = %d\n",bytesfrom);
	printf("Bytes to memory = %d\n",bytesto);
	fclose(fp);
	return 0;
}
